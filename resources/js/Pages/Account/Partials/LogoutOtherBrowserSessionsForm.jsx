import { useState, useRef, useEffect } from 'react';
import {
  ComputerDesktopIcon,
  DevicePhoneMobileIcon,
  DeviceTabletIcon,
  TvIcon,
  CubeIcon
} from '@heroicons/react/24/outline';
import { useForm } from '@inertiajs/react';
import ActionMessage from '@/Components/ActionMessage';
import ActionSection from '@/Components/ActionSection';
import DialogModal from '@/Components/DialogModal';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import Checkbox from '@/Components/Checkbox';
import InputLabel from '@/Components/InputLabel';

const DeviceIcon = {
  'desktop': ComputerDesktopIcon,
  'smartphone': DevicePhoneMobileIcon,
  'tablet': DeviceTabletIcon,
  'smart tv': TvIcon,
  'console': CubeIcon
};

const createModalContent = ({
  title,
  text,
  inputRef,
  value,
  onChange,
  onKeyUp,
  message,
  closeModal,
  disabled,
  logout,
  buttonText
}) => ({
  title,
  content: <>
    {text}

    <div className="mt-4">
      <TextInput
        id="password"
        ref={inputRef}
        value={value}
        onChange={onChange}
        type="password"
        className="mt-1 block w-3/4"
        placeholder="Password"
        autoComplete="current-password"
        onKeyUp={onKeyUp}
      />

      <InputError message={message} className="mt-2" />
    </div>
  </>,
  footer: <>
    <div className="mt-4 flex justify-end">
      <SecondaryButton onClick={closeModal}>
        Cancel
      </SecondaryButton>

      <PrimaryButton
        className="ms-3"
        disabled={disabled}
        onClick={logout}
      >
        {buttonText}
      </PrimaryButton>
    </div>
  </>
});

const LogoutOtherBrowserSessionsForm = ({ sessions }) => {
  const [ confirmingOtherLogout, setConfirmingOtherLogout ] = useState(false);
  const [ confirmingSelectedLogout, setConfirmingSelectedLogout ] = useState(false);
  const [ selectedSessions, setSelectedSessions ] = useState([]);
  const passwordInput = useRef(null);
  const form = useForm({ password: '' });

  useEffect(() => {
    if (confirmingOtherLogout || confirmingSelectedLogout) {
      setTimeout(() => {
          passwordInput.current.focus();
      }, 500);
    } else {
      form.reset();
    }
  }, [confirmingOtherLogout, confirmingSelectedLogout]);

  const confirmOtherLogout = () => setConfirmingOtherLogout(true);
  const confirmSelectedLogout = () => setConfirmingSelectedLogout(true);

  const closeOtherModal = () => setConfirmingOtherLogout(false);
  const closeSelectedModal = () => setConfirmingSelectedLogout(false);

  const handleOnChange = e => {
    form.setData(e.target.id, e.target.value);
  };
  const handleOnKeyUpOther = e => e.key === 'Enter' && logoutOtherBrowserSessions();
  const handleOnKeyUpSelected = e => e.key === 'Enter' && logoutSelectedSessions();
  const handleSessionSelection = sessionId => () =>
    setSelectedSessions(prev =>
      prev.includes(sessionId)
        ? prev.filter(id => id !== sessionId)
        : [...prev, sessionId]
    );

  const logoutOtherBrowserSessions = () =>
    form.delete(route('other-browser-sessions.destroy'), {
      preserveScroll: true,
      onSuccess: closeOtherModal,
      onError: () => passwordInput.current.focus(),
      onFinish: form.reset,
    });

  const logoutSelectedSessions = () =>
    form.delete(route('other-browser-session.destroy', { session: selectedSessions.join(',') }), {
      preserveScroll: true,
      onSuccess: () => {
        setSelectedSessions([]);
        closeSelectedModal();
      },
      onError: () => passwordInput.current.focus(),
      onFinish: form.reset,
    });

  const slotsDefault = {
    inputRef: passwordInput,
    value: form.data.password,
    onChange: handleOnChange,
    message: form.errors.password,
    disabled: form.processing,
  };

  const otherBrowsersSlots = createModalContent({
    ...slotsDefault,
    title: 'Log Out Other Browser Sessions',
    text: 'Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.',
    closeModal: closeOtherModal,
    onKeyUp: handleOnKeyUpOther,
    logout: logoutOtherBrowserSessions,
    buttonText: 'Log Out Other Browser Sessions'
  });

  const selectedBrowsersSlots = createModalContent({
    ...slotsDefault,
    title: 'Log Out Selected Browser Sessions',
    text: 'Please enter your password to confirm you would like to log out of your selected browser sessions across all of your devices.',
    closeModal: closeSelectedModal,
    onKeyUp: handleOnKeyUpSelected,
    logout: logoutSelectedSessions,
    buttonText: 'Log Out Selected Browser Sessions'
  });

  return (
    <ActionSection
      title="Browser Sessions"
      description="Manage and log out your active sessions on other browsers and devices."
    >
      <div className="max-w-xl text-sm text-gray-600 dark:text-gray-400">
        If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your
        recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been
        compromised, you should also update your password.
      </div>

      {/* Other Browser Sessions */}
      {sessions.length > 0 &&
        <div className="mt-5 space-y-6">
          {sessions.map(session => {
            const IconComponent = DeviceIcon[session.agent.device];
            const osName = session.agent.os.name;
            const osVersion = session.agent.os.version;
            const browserName = session.agent.browser.name;
            const browserVersion = session.agent.browser.version;
            const displayText = osName + (osVersion ? ` ${osVersion}` : '')
              + ` - ${browserName} ${browserVersion}`;

            return (
              <div key={session.id} className="flex items-center">
                {session.is_current_device
                  ? <Checkbox disabled/>
                  :
                  <Checkbox
                    id={session.id}
                    checked={selectedSessions.includes(session.id)}
                    onChange={handleSessionSelection(session.id)}
                  />
                }

                <InputLabel htmlFor={session.id} className="ms-2 flex items-center">
                  {session.agent.device &&
                    <IconComponent className="size-8 text-gray-500"/>
                  }

                  <div className="ms-3">
                    <div className="text-sm text-gray-600 dark:text-gray-400">
                      {displayText}
                    </div>

                    <div className="text-xs text-gray-500">
                      {session.ip_address},
                      {session.is_current_device
                        ? <span className="text-green-500 font-semibold">This device</span>
                        : <span>Last active {session.last_active}</span>
                      }
                    </div>
                  </div>
                </InputLabel>
              </div>
            );
          })}
        </div>
      }

      <div className="flex items-center mt-5">
        {selectedSessions.length > 0 ? (
          <SecondaryButton onClick={confirmSelectedLogout} disabled={form.processing}>
            Log Out Selected Browser Sessions
          </SecondaryButton>
        ) : (
          <PrimaryButton onClick={confirmOtherLogout} disabled={form.processing || sessions.length <= 1}>
            Log Out Other Browser Sessions
          </PrimaryButton>
        )}

        <ActionMessage on={form.recentlySuccessful} className="ms-3">
          Done.
        </ActionMessage>
      </div>

      {/* Log Out Other Devices Confirmation Modal */}
      <DialogModal
        show={confirmingOtherLogout}
        onClose={closeOtherModal}
        slots={otherBrowsersSlots}
      />

      {/* Log Out Selected Devices Confirmation Modal */}
      <DialogModal
        show={confirmingSelectedLogout}
        onClose={closeSelectedModal}
        slots={selectedBrowsersSlots}
      />
    </ActionSection>
  );
};

export default LogoutOtherBrowserSessionsForm;
