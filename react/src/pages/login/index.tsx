import { Button, Form, FormProps, Input } from 'antd';
import "./login.css";
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

type FieldType = {
    email?: string;
    password?: string;
};



const Login = () => {

    const navigate = useNavigate();

    const handleLogin = async (request: FieldType) => {
        try {
            const response = await axios.post("http://127.0.0.1:8000/api/login", request);
            navigate("/")
            console.log("Login muvaffaqiyatli:", response.data);

            // localStorage.setItem("token", response.data.token); // Tokenni saqlash
        } catch (err) {

            console.error("Xato:", err);
        }
    };
    const onFinish: FormProps<FieldType>['onFinish'] = (values) => {
        console.log(values);
        handleLogin(values)
    };

    const onFinishFailed: FormProps<FieldType>['onFinishFailed'] = (errorInfo) => {
        console.log('Failed:', errorInfo);
    };
    return (
        <div className='form-container'>
            <Form
                name="basic"
                labelCol={{ span: 8 }}
                wrapperCol={{ span: 16 }}
                style={{ maxWidth: 600 }}
                initialValues={{ remember: true }}
                onFinish={onFinish}
                onFinishFailed={onFinishFailed}
                autoComplete="off"
            >
                <Form.Item<FieldType>
                    label="email"
                    name="email"
                    rules={[{ required: true, message: 'Please input your email!' }]}
                >
                    <Input />
                </Form.Item>

                <Form.Item<FieldType>
                    label="Password"
                    name="password"
                    rules={[{ required: true, message: 'Please input your password!' }]}
                >
                    <Input.Password />
                </Form.Item>



                <Form.Item label={null}>
                    <Button type="primary" htmlType="submit">
                        Submit
                    </Button>
                </Form.Item>
            </Form>
        </div>
    )
}

export default Login