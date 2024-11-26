import React from "react";
import { Link } from "react-router-dom";
import logo from "../assets/Logo.png";
import cart from "../assets/Empty Cart.svg";

class Navbar extends React.Component {
  state = {
    cartStatus: "closed",
  };

  toggleCart = () => {
    this.setState((prevState) => ({
      cartStatus: prevState.cartStatus === "closed" ? "open" : "closed",
    }));
  };

  render() {
    const { cartStatus } = this.state;
    const { cartItems } = this.props; // Use cartItems passed as a prop
    console.log(cartItems); // This should display the updated cart items

    return (
      <nav className="navbar">
        <ul className="sections">
          <li><Link to="/">ALL</Link></li>
          <li><Link to="/cloth">Cloth</Link></li>
          <li><Link to="/tech">Tech</Link></li>
        </ul>
        <img src={logo} alt="Logo" id="logo" />

        <div className="cart-menu">
          <button id="cart" data-cart-status={cartStatus} onClick={this.toggleCart}>
            <img src={cart} alt="Cart" className="img" />
          </button>
          <ul className="cart-items">
            {cartItems.map((item, index) => (
              <li key={index}>
                <strong>ID:</strong> {item.product_id}, <strong>Price:</strong> ${item.price},
                <strong>Attributes:</strong> {Object.entries(item.attributes)
                  .map(([key, value]) => `${key}: ${value}`)
                  .join(", ")}
              </li>
            ))}
          </ul>
        </div>
      </nav>
    );
  }
}

export default Navbar;
