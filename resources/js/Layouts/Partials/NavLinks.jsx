const NavLinks = ({ authenticated, Component }) =>
  <>
    <Component href={route('home')} active={route().current('home')}>
      Home
    </Component>
    <Component href={route('room.index')} active={route().current('room.index') || route().current('room.show')}>
      Our Rooms
    </Component>
  </>;

export default NavLinks;
