import { Head, Link, useForm } from '@inertiajs/react';
import { useAuth } from '@/contexts';
import AuthenticationCard from '@/Components/AuthenticationCard';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

const Login = ({ canResetPassword, status }) => {
  const {
    data,
    setData,
    post,
    processing,
    errors,
    reset
  } = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const { login } = useAuth();

  const handleOnChange = e => setData(e.target.id, e.target.value);
  const handleCheckboxOnChange = isChecked => setData('remember', isChecked ? 'on' : false);

  const submit = e => {
    e.preventDefault();
    post(route('login'), {
      onSuccess: (data) => login(data.props.auth.user),
      onFinish: () => reset('password'),
    });
  };

  return <>
    <Head title="Log in" />

    <AuthenticationCard logo={<AuthenticationCardLogo />}>
      {status &&
        <div className="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
          {status}
        </div>
      }

      <form onSubmit={submit}>
        <InputLabel htmlFor="email" value="Email" />
        <TextInput
          id="email"
          value={data.email}
          onChange={handleOnChange}
          type="email"
          className="mt-1 block w-full"
          required
          autoFocus
          autoComplete="username"
        />
        <InputError className="mt-2" message={errors.email} />

        <div className="mt-4">
          <InputLabel htmlFor="password" value="Password" />
          <TextInput
            id="password"
            value={data.password}
            onChange={handleOnChange}
            type="password"
            className="mt-1 block w-full"
            required
            autoComplete="current-password"
          />
          <InputError className="mt-2" message={errors.password} />
        </div>

        <div className="block mt-4">
          <label className="flex items-center">
            <Checkbox
              checked={data.remember}
              onChange={handleCheckboxOnChange}
            />
            <span className="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
          </label>
        </div>

        <div className="flex items-center justify-end mt-4">
          {canResetPassword &&
            <Link
              href={route('password.request')}
              className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            >
              Forgot your password?
            </Link>
          }

          <PrimaryButton className="ms-4" disabled={processing}>
            Log in
          </PrimaryButton>
        </div>
      </form>
    </AuthenticationCard>
  </>;
};

export default Login;
