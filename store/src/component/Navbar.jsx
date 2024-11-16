import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import logo from '../assets/Logo.png';
import cart from '../assets/Empty Cart.svg';

class Navbar extends Component {
  render() {
    return (
      <nav className="navbar">
        <ul className="sections">
          <li><Link to="/" >ALL</Link></li>
          <li><Link to="/cloth">Cloth</Link></li>
          <li><Link to="/tech">Tech</Link></li>
        </ul>
        <img src={logo} alt="Logo" className="img" />
        
        <div className='cart'>
        <img src={cart} alt="Cart" className="img" />
         <ul className='cart-items'>
          <li>item 1</li>
          <li>item 2</li>
         </ul>
        </div>
      </nav>
    );
  }
}

export default Navbar;
