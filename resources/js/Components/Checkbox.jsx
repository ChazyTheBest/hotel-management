import { useState } from 'react';

const Checkbox = ({ type = 'checkbox', checked = false, onChange, className = '', ...props }) => {
  const [proxyChecked, setProxyChecked] = useState(checked);

  const handleOnChange = e => {
    setProxyChecked(e.target.checked);
    onChange(type === 'checkbox' ? e.target.checked : e.target.value);
  };

  return <input
    {...props}
    type={type}
    checked={proxyChecked}
    onChange={handleOnChange}
    className={`rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed ${className}`}
  />;
};

export default Checkbox;
