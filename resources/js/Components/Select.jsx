import { useState } from 'react';

const classes = 'block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:border-indigo-500 dark:focus:border-indigo-600 sm:text-sm rounded-md';

const Select = ({ className = '', value, onChange, options, ...props }) => {
  const handleOnChange = e => onChange(e.target.value);

  return (
    <select
      {...props}
      value={value}
      onChange={handleOnChange}
      className={classes + ' ' + className}
    >
      {options.map(option =>
        <option
          key={option.id}
          value={option.id}
        >
          {option.name}
        </option>
      )}
    </select>
  );
};

export default Select;
