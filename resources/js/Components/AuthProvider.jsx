import { useState } from 'react';
import { router } from '@inertiajs/react';
import { AuthContext } from '@/contexts';

const AuthProvider = ({ auth, children }) => {
  const [ authenticated, setAuthenticated ] = useState(!!auth.user);
  const [ user, setUser ] = useState(auth.user);

  const login = (user) => {
    setUser(user);
    setAuthenticated(!!user);
  };

  const logout = () => {
    setUser(null);
    setAuthenticated(false);

    router.post(route('logout'));
  };

  return (
    <AuthContext.Provider value={{ authenticated, user, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

export default AuthProvider;
