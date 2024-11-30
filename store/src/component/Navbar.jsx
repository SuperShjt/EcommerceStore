import React from "react";
import { Link } from "react-router-dom";
import logo from "../assets/Logo.png";
import cart from "../assets/Empty Cart.svg";
import AddOrder from "./AddOrder";

class Navbar extends React.Component {
  state = {
    cartStatus: "closed",
  };

  toggleCart = () => {
    this.setState((prevState) => ({
      cartStatus: prevState.cartStatus === "closed" ? "open" : "closed",
    }));
  };
   


  calculateTotalPrice = () => {
    const { cartItems } = this.props; // Use cartItems from props
    if (!cartItems || cartItems.length === 0) return 0;
    return cartItems.reduce((total, item) => total + (item.price || 0), 0).toFixed(2);
  };
  
  render() {
    const { cartStatus } = this.state;
    const { cartItems, clearCart  } = this.props; // Use cartItems passed as a prop
    const totalPrice = this.calculateTotalPrice(); // Calculate total price dynamically
    
    return (
      <nav className="navbar">
        <ul className="sections">
          <li><Link to="/">ALL</Link></li>
          <li><Link to="/cloth">Clothes</Link></li>
          <li><Link to="/tech">Tech</Link></li>
        </ul>
        <img src={logo} alt="Logo" id="logo" />

        <div className="cart-menu">
          <button id="cart" data-cart-status={cartStatus} onClick={this.toggleCart}>
            <img src={cart} alt="Cart" className="img" />
            <h6 id="cart-counter">{cartItems.length}</h6> 
         
          </button>
          {cartStatus === "open" && (
            <div className="current-cart">
              <p>My Bag {cartItems.length} items</p>
              {cartItems.length === 0 ? <h2> cart is currently empty</h2> : 
              <ul className="cart-items">
              {cartItems.map((item, index) => (
                <li className="cart-item" key={index}>
                  <div className="item-details">
                    <p>{item.product_id}</p>
                    <p>${item.price}</p>
                    <p>
                      {Object.entries(item.attributes)
                        .map(([key, value]) => `${key}: ${value}`)
                        .join(", ")}
                    </p>
                  </div>
                  <img className="cart-img" src={item.image} alt="" />
                </li>

              ))}
            </ul>
              }
                 <p><strong>Total Price:</strong> ${totalPrice}</p>
                <AddOrder cartItems={cartItems} clearCart={clearCart}  />
            </div>
          )}
        </div>
      </nav>
    );
  }
}

export default Navbar;
