<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Aws\Exception\AwsException;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Số lượng phần tử trên mỗi trang (mặc định là 10)
        $lesson = Lesson::paginate($perPage);

        return response()->json($lesson);
    }
    public function hello()
    {
        return response()->json(['message' => 'Hello from API!']);
    }

    public function random(Request $request)
    {
        $limit = $request->query('limit', 5);
        $lessons = Lesson::whereNotNull('videoAddress')->inRandomOrder()->limit($limit)->get();

        $s3Disk = Storage::disk('s3');

        $response = $lessons->map(function ($lesson) use ($s3Disk) {
            $videoPath = ltrim(parse_url($lesson->videoAddress, PHP_URL_PATH), '/');

            // Tạo signed URL thay vì link public
            $signedUrl = $s3Disk->temporaryUrl($videoPath, now()->addMinutes(30));

            return [
                'id' => $lesson->id,
                'lessonName' => $lesson->lessonName,
                'description' => $lesson->description,
                'videoUrl' => $signedUrl,
            ];
        });

        return response()->json($response);
    }

    // public function storeWithVideo(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'idCourse' => 'required|integer',
    //         'idCopyrightType' => 'required|integer',
    //         'idStatusType' => 'required|integer',
    //         'lessonName' => 'required|string|max:255',
    //         'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:102400', // Giới hạn 100MB
    //     ]);

    //     // 1. Upload video lên S3
    //     $file = $request->file('video');
    //     $filePath = 'videos/' . uniqid() . '.' . $file->getClientOriginalExtension();

    //     $path = Storage::disk('s3')->put($filePath, file_get_contents($file));
    //     $videoUrl = Storage::disk('s3')->url($filePath); // Lấy public URL

    //     // 2. Tạo lesson mới
    //     $lesson = Lesson::create([
    //         'idCourse' => $validatedData['idCourse'],
    //         'idCopyrightType' => $validatedData['idCopyrightType'],
    //         'idStatusType' => $validatedData['idStatusType'],
    //         'lessonName' => $validatedData['lessonName'],
    //         'videoAddress' => $videoUrl,
    //         'description' => '',
    //         'quantityView' => 0,
    //         'quantityComment' => 0,
    //         'quantityFavorite' => 0,
    //         'quantityShared' => 0,
    //         'quantitySaved' => 0,
    //         'timeCreated' => now(),
    //     ]);

    //     return response()->json([
    //         'message' => 'Upload & Create Lesson success',
    //         'lesson' => $lesson
    //     ]);
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $validatedData = $request->validate([
            'idCourse' => 'required|integer|exists:course,idCourse', // Kiểm tra course tồn tại
            'idCopyrightType' => 'required|integer|exists:copyrighttype,idCopyrightType', // Kiểm tra copyright type
            'idStatusType' => 'required|integer|exists:statustype,idStatusType', // Kiểm tra status type
            'lessonName' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000', // Cho phép description tùy chọn
            'video' => 'required|file|mimes:mp4,mov,avi,wmv,mkv|max:102400', // 100MB
        ]);

        try {
            // 2. Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            return DB::transaction(function () use ($validatedData, $request) {
                // 3. Upload video lên S3
                $file = $request->file('video');
                $extension = $file->getClientOriginalExtension();
                // Tạo tên file có ý nghĩa hơn
                $fileName = 'courses/' . $validatedData['idCourse'] . '/lessons/' . Str::slug($validatedData['lessonName']) . '-' . uniqid() . '.' . $extension;

                // Upload file lên S3
                // $path = Storage::disk('s3')->put($fileName, file_get_contents($file), 'public');
                // Trong function store()
                try {
                    $content = file_get_contents($file->getPathname());
                    if ($content === false) {
                        throw new \Exception('Không thể đọc nội dung file video');
                    }

                    $s3Disk = Storage::disk('s3');

                    // Bắt lỗi exception khi upload
                    try {
                        $result = $s3Disk->put($fileName, $content);
                    } catch (\Throwable $uploadError) {
                        \Log::error('S3 upload failed', [
                            'error' => $uploadError->getMessage(),
                            'trace' => $uploadError->getTraceAsString(),
                        ]);
                        throw new \Exception('Không thể upload video lên S3: ' . $uploadError->getMessage());
                    }

                    if (!$result) {
                        \Log::error('S3 put returned false', [
                            'disk' => 's3',
                            'fileName' => $fileName
                        ]);
                        throw new \Exception('Không thể upload video lên S3: Kết quả put trả về false.');
                    }

                    \Log::info('Upload thành công: ' . $fileName);
                } catch (\Exception $e) {
                    throw new \Exception('Lỗi upload: ' . $e->getMessage());
                }

                // Lấy URL công khai
                $videoUrl = Storage::disk('s3')->url($fileName);

                // 4. Tạo lesson mới
                $lesson = Lesson::create([
                    'idCourse' => $validatedData['idCourse'],
                    'idCopyrightType' => $validatedData['idCopyrightType'],
                    'idStatusType' => $validatedData['idStatusType'],
                    'lessonName' => $validatedData['lessonName'],
                    'videoAddress' => $videoUrl,
                    'description' => $validatedData['description'] ?? '',
                    'quantityView' => 0,
                    'quantityComment' => 0,
                    'quantityFavorite' => 0,
                    'quantityShared' => 0,
                    'quantitySaved' => 0,
                ]);

                // 5. Trả về response
                return response()->json([
                    'message' => 'Tạo lesson và upload video thành công',
                    'lesson' => $lesson
                ], 201);
            });
        } catch (\Exception $e) {
            // 6. Xử lý lỗi
            return response()->json([
                'message' => 'Có lỗi xảy ra khi tạo lesson',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        return response()->json($lesson);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validatedData = $request->validate([
            'idCourse' => 'integer',
            'idCopyrightType' => 'integer',
            'idStatusType' => 'integer',
            'lessonName' => 'string|max:255',
            'videoAddress' => 'nullable|string',
            'description' => 'nullable|string',
            'quantityView' => 'integer',
            'quantityComment' => 'integer',
            'quantityFavorite' => 'integer',
            'quantityShared' => 'integer',
            'quantitySaved' => 'integer',
            'timeCreated' => 'date',
        ]);

        $lesson->update($validatedData);
        return response()->json($lesson);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
