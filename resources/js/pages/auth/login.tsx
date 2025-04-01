import { Head } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/auth-layout';

interface LoginProps {
    status?: string;
    canResetPassword: boolean;
}

export default function Login({ status }: LoginProps) {
    const handleGoogleLogin = () => {
        // Thực hiện gọi API để đăng nhập qua Google
        window.location.href = route('google.login'); // Đây là route của bạn để xử lý login Google
    };

    return (
        <AuthLayout title="Log in to your account" description="Log in using your Google account">
            <Head title="Log in" />

            <form className="flex flex-col gap-6">
                <div className="grid gap-6">
                    <div className="grid gap-2">
                        {/* Nút đăng nhập Google */}
                        <Button
                            type="button"
                            onClick={handleGoogleLogin}
                            className="mt-4 w-full"
                            disabled={false} // Đảm bảo nút không bị disable
                        >
                            {<LoaderCircle className="h-4 w-4 animate-spin" />}
                            Log in with Google
                        </Button>
                    </div>
                </div>

                {/* Hiển thị thông báo trạng thái nếu có */}
                {status && <div className="mb-4 text-center text-sm font-medium text-green-600">{status}</div>}
            </form>
        </AuthLayout>
    );
}
