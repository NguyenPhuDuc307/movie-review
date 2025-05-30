<?php
class AuthController extends Controller {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            if (empty($username) || empty($password)) {
                $this->setFlash('error', 'Vui lòng nhập đầy đủ thông tin.');
                $this->view('auth/login');
                return;
            }
            
            $userModel = $this->model('User');
            $user = $userModel->login($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                
                $this->setFlash('success', 'Đăng nhập thành công!');
                $this->redirect('home');
            } else {
                $this->setFlash('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
            }
        }
        
        $this->view('auth/login');
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'full_name' => trim($_POST['full_name'])
            ];
            
            // Validation
            $errors = [];
            
            if (empty($data['username'])) {
                $errors[] = 'Tên đăng nhập không được để trống.';
            } elseif (strlen($data['username']) < 3) {
                $errors[] = 'Tên đăng nhập phải có ít nhất 3 ký tự.';
            }
            
            if (empty($data['email'])) {
                $errors[] = 'Email không được để trống.';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ.';
            }
            
            if (empty($data['password'])) {
                $errors[] = 'Mật khẩu không được để trống.';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            }
            
            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = 'Xác nhận mật khẩu không khớp.';
            }
            
            if (empty($data['full_name'])) {
                $errors[] = 'Họ và tên không được để trống.';
            }
            
            if (empty($errors)) {
                $userModel = $this->model('User');
                
                // Check if username exists
                if ($userModel->usernameExists($data['username'])) {
                    $errors[] = 'Tên đăng nhập đã tồn tại.';
                }
                
                // Check if email exists
                if ($userModel->emailExists($data['email'])) {
                    $errors[] = 'Email đã được sử dụng.';
                }
                
                if (empty($errors)) {
                    // Remove confirm_password from data
                    unset($data['confirm_password']);
                    
                    if ($userModel->register($data)) {
                        $this->setFlash('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
                        $this->redirect('login');
                    } else {
                        $this->setFlash('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                }
            }
            
            if (!empty($errors)) {
                $this->setFlash('error', implode('<br>', $errors));
            }
        }
        
        $this->view('auth/register');
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('home');
    }
}
?>
