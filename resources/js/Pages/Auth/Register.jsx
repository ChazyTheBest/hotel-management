import { Head, Link, useForm } from '@inertiajs/react';
import { useAuth } from '../../contexts';
import AuthenticationCard from '@/Components/AuthenticationCard';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

const Register = props => {
  const {
    data,
    setData,
    post,
    processing,
    errors,
    reset
  } = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
  });

  const { login } = useAuth();

  const handleOnChange = e => setData(e.target.id, e.target.value);
  const handleOnChangeCheckbox = isChecked => setData('terms', isChecked ? 'on' : false);

  const submit = e => {
    e.preventDefault();
    post(route('register'), {
      onSuccess: (data) => login(data.props.auth.user),
      onFinish: () => reset('password', 'password_confirmation'),
    });
  };

  return <>
    <Head title="Register" />

    <AuthenticationCard logo={<AuthenticationCardLogo />}>
      <form onSubmit={submit}>
        <InputLabel htmlFor="name" value="Name" />
        <TextInput
          id="name"
          value={data.name}
          onChange={handleOnChange}
          type="text"
          className="mt-1 block w-full"
          required
          autoFocus
          autoComplete="name"
        />
        <InputError className="mt-2" message={errors.name} />

        <div className="mt-4">
          <InputLabel htmlFor="email" value="Email" />
          <TextInput
            id="email"
            value={data.email}
            onChange={handleOnChange}
            type="email"
            className="mt-1 block w-full"
            required
            autoComplete="username"
          />
          <InputError className="mt-2" message={errors.email} />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="password" value="Password" />
          <TextInput
            id="password"
            value={data.password}
            onChange={handleOnChange}
            type="password"
            className="mt-1 block w-full"
            required
            autoComplete="new-password"
          />
          <InputError className="mt-2" message={errors.password} />
        </div>

        <div className="mt-4">
          <InputLabel htmlFor="password_confirmation" value="Confirm Password" />
          <TextInput
            id="password_confirmation"
            value={data.password_confirmation}
            onChange={handleOnChange}
            type="password"
            className="mt-1 block w-full"
            required
            autoComplete="new-password"
          />
          <InputError className="mt-2" message={errors.password_confirmation} />
        </div>

        {route().has('terms.show') && route().has('policy.show') &&
          <div className="mt-4">
            <InputLabel for="terms">
              <div className="flex items-center">
                <Checkbox
                  id="terms"
                  checked={data.terms}
                  onChange={handleOnChangeCheckbox}
                  required
                />
                <div className="ms-2">
                  I agree to the
                  <a
                    target="_blank"
                    href={route('terms.show')}
                    className="mx-1 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                  >
                    Terms of Service
                  </a>
                  and
                  <a
                    target="_blank"
                    href={route('policy.show')}
                    className="ms-1 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                  >
                    Privacy Policy
                  </a>
                </div>
              </div>
              <InputError className="mt-2" message={errors.terms} />
            </InputLabel>
          </div>
        }

        <div className="flex items-center justify-end mt-4">
          <Link
            href={route('login')}
            className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
          >
            Already registered?
          </Link>

          <PrimaryButton className="ms-4" disabled={processing}>
            Register
          </PrimaryButton>
        </div>
      </form>
    </AuthenticationCard>
  </>;
};

export default Register;
