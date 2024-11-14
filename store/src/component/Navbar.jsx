import React, { Component } from 'react';
import logo from '../assets/logo.png';
import cart from '../assets/cart.png';

class Navbar extends Component {
    render() {
        return (
            <navbar className="navbar">
                <ul className="sections">
                    <li><a href="#">ALL</a></li>
                    <li><a href="#">Cloth</a></li>
                    <li><a href="#">Tech</a></li>
                </ul>
                <img src={logo} alt='Logo' className='img' />
                <img src={cart} alt='Cart' className='img' />
            </navbar>
        );
    }
}

export default Navbar;