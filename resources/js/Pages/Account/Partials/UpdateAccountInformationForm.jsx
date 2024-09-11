import { useState, useRef } from 'react';
import { Link, useForm } from '@inertiajs/react';
import ActionMessage from '@/Components/ActionMessage';
import FormSection from '@/Components/FormSection';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';

const UpdateAccountInformationForm = ({ user }) => {
  const [verificationLinkSent, setVerificationLinkSent] = useState(false);
  const [photoPreview, setPhotoPreview] = useState(null);
  const photoInput = useRef(null);

  const form = useForm({
    _method: 'PUT',
    name: user.name,
    email: user.email,
    photo: null,
  });

  const handleOnChange = e => form.setData(e.target.id, e.target.value);

  const updateAccountInformation = e => {
    e.preventDefault();

    form.post(route('user-account-information.update'), {
      errorBag: 'updateAccountInformation',
      preserveScroll: true,
      onSuccess: () => clearPhotoFileInput(),
    });
  };

  const sendEmailVerification = () => setVerificationLinkSent(true);

  const selectNewPhoto = () => photoInput.current.click();

  const updatePhotoPreview = () => {
    const photo = photoInput.current.files[0];

    if (!photo) return;

    const reader = new FileReader();
    reader.onload = e => setPhotoPreview(e.target.result);

    reader.readAsDataURL(photo);

    form.setData('photo', photo);
  };

  const deletePhoto = () => {
    form.delete(route('current-user-photo.destroy'), {
      preserveScroll: true,
      onSuccess: () => {
        setPhotoPreview(null);
        clearPhotoFileInput();
      },
    });
  };

  const clearPhotoFileInput = () => {
    if (photoInput.current?.value) {
      photoInput.current.value = null;
    }
  };

  return <FormSection
    title="Account Information"
    description="Update your account's account information and email address."
    form={<>
      {/* Account Photo */}
      {user.managesAccountPhotos &&
        <div className="col-span-6 sm:col-span-4">
          {/* Account Photo File Input */}
          <input
            id="photo"
            ref={photoInput}
            type="file"
            className="hidden"
            onChange={updatePhotoPreview}
          />

          <InputLabel htmlFor="photo" value="Photo" />

          <div className="mt-2">
            {photoPreview ?
              <span
                className="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                style={{ backgroundImage: `url(${photoPreview})` }}
              />
            :
              <img src={user.account_photo_url} alt={user.name} className="rounded-full h-20 w-20 object-cover" />
            }
          </div>

          <SecondaryButton className="mt-2 me-2" onClick={selectNewPhoto}>
            Select A New Photo
          </SecondaryButton>

          {user.account_photo_path &&
            <SecondaryButton className="mt-2" onClick={deletePhoto}>
              Remove Photo
            </SecondaryButton>
          }

          <InputError message={form.errors.photo} className="mt-2" />
        </div>
      }

      {/* Name */}
      <div className="col-span-6 sm:col-span-4">
        <InputLabel htmlFor="name" value="Name" />
        <TextInput
          id="name"
          value={form.data.name}
          onChange={handleOnChange}
          type="text"
          className="mt-1 block w-full"
          required
          autoComplete="name"
        />
        <InputError message={form.errors.name} className="mt-2" />
      </div>

      {/* Email */}
      <div className="col-span-6 sm:col-span-4">
        <InputLabel htmlFor="email" value="Email" />
        <TextInput
          id="email"
          value={form.data.email}
          onChange={handleOnChange}
          type="email"
          className="mt-1 block w-full"
          required
          autoComplete="username"
        />
        <InputError message={form.errors.email} className="mt-2" />
        {user.email_verified_at === null &&
          <>
            <p className="text-sm mt-2 dark:text-white">
              Your email address is unverified.
              <Link
                href={route('verification.send')}
                method="post"
                as="button"
                type="button"
                className="ms-1 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                onClick={sendEmailVerification}
              >
                Click here to re-send the verification email.
              </Link>
            </p>
            {verificationLinkSent &&
              <div className="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                A new verification link has been sent to your email address.
              </div>
            }
          </>
        }
      </div>
    </>}
    actions={<>
      <ActionMessage on={form.recentlySuccessful} className="me-3">
        Saved.
      </ActionMessage>

      <PrimaryButton disabled={form.processing}>
        Save
      </PrimaryButton>
    </>}
    onSubmit={updateAccountInformation}
  />;
};

export default UpdateAccountInformationForm;
