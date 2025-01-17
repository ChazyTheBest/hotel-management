const InputError = ({ className, message }) => message &&
  <p className={`text-sm text-red-600 dark:text-red-400 ${className}`}>
    {message}
  </p>;

export default InputError;
