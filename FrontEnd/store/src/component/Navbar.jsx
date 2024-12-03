import React from "react";
import { NavLink } from "react-router-dom";
import logo from "../assets/Logo.png";
import cart from "../assets/Empty Cart.svg";
import AddOrder from "./AddOrder";

class Navbar extends React.Component {
  toggleCart = () => {
    this.props.toggleCart(); // Call toggleCart from the parent component
  };

  calculateTotalPrice = () => {
    const { cartItems } = this.props; // Use cartItems from props
    if (!cartItems || cartItems.length === 0) return 0;

    return cartItems
      .reduce((total, item) => total + item.price * (item.quantity || 1), 0)
      .toFixed(2); // Multiply price by quantity and sum up
  };

  handleIncreaseQuantity = (productId, attributes) => {
    console.log("Increase Quantity for Product ID:", productId, "with attributes:", attributes);

    this.props.updateCartItems((prevCartItems) =>
      prevCartItems.map((item) =>
        item.product_id === productId && this.areAttributesEqual(item.attributes, attributes)
          ? { ...item, quantity: item.quantity + 1 }
          : item
      )
    );
  };

  handleDecreaseQuantity = (productId, attributes) => {
    console.log("Decrease Quantity for Product ID:", productId, "with attributes:", attributes);
    this.props.updateCartItems((prevCartItems) =>
      prevCartItems.map((item) =>
        item.product_id === productId && this.areAttributesEqual(item.attributes, attributes) && item.quantity > 1
          ? { ...item, quantity: item.quantity - 1 }
          : item
      )
    );
  };

  areAttributesEqual = (attributes1, attributes2) => {
    // Assuming attributes are an object, convert both to sorted arrays of key-value strings
    const entries1 = Object.entries(attributes1).sort();
    const entries2 = Object.entries(attributes2).sort();

    // Compare both sorted arrays
    return JSON.stringify(entries1) === JSON.stringify(entries2);
  };

  render() {
    const { cartStatus, cartItems, clearCart } = this.props; // Get cartStatus from props
    const totalPrice = this.calculateTotalPrice(); // Calculate total price dynamically

    console.log("Cart Items:", cartItems);
    console.log("Total Price:", totalPrice);

    return (
      <nav className="navbar">
        <ul className="sections">
          <li>
            <NavLink to="/"   className={({ isActive }) => (isActive ? "active-link" : "")} >ALL</NavLink>
          </li>
          <li>
            <NavLink to="/cloth"  className={({ isActive }) => (isActive ? "active-link" : "")}>Clothes</NavLink>
          </li>
          <li>
            <NavLink to="/tech"  className={({ isActive }) => (isActive ? "active-link" : "")}>Tech</NavLink>
          </li>
        </ul>
        <img src={logo} alt="Logo" id="logo" />

        <div className="cart-menu">
          <button id="cart" data-cart-status={cartStatus} onClick={this.toggleCart}  data-testid='cart-btn' >
            <img src={cart} alt="Cart" className="img" />
            <h6 id="cart-counter">{cartItems.length}</h6>
          </button>
          {cartStatus === "open" && (
            <div className="current-cart">
              <p data-testid='cart-total'> <strong>My Bag</strong> {cartItems.length} items</p>
              {cartItems.length === 0 ? (
                <h2>Cart is currently empty</h2>
              ) : (
                <ul className="cart-items">
                  {cartItems.map((item, index) => (
                    <li className="cart-item" key={index}>
                      <div className="item-details">
                        <p>{item.product_name}</p>
                        <p>${item.price}</p>
                        <div className="cart-attributes">
                            {Object.entries(item.allAttributes).map(([key, options], attrIndex) => (
                              <div key={attrIndex} className="cart-attribute">
                                <p data-testid={`cart-item-attribute-${key}`}>{key}:</p>
                                <div className="cart-attribute-options">
                                  {options.map((option, optionIndex) => (
                                    key.toLowerCase() === "color" ? (
                                      <div
                                        key={optionIndex}
                                        className={`cart-attribute-color ${
                                          option.valuex === item.attributes[key] ? "selected" : ""
                                        }`}
                                        style={{ backgroundColor: option.valuex }}
                                      />
                                    ) : (
                                      <div
                                        key={optionIndex}
                                        className={`cart-attribute-box ${
                                          option.valuex === item.attributes[key] ? "selected" : ""
                                        }`}
                                      >
                                        {option.display_value}
                                      </div>
                                    )
                                  ))}
                                </div>
                              </div>
                            ))}
                          </div>
                      </div>
                        <div className="quantity-control">
                        <button data-testid='cart-item-amount-increase' 
                            onClick={() =>
                              this.handleIncreaseQuantity(item.product_id, item.attributes)
                            }
                          >
                            +
                          </button>
                          
                          <span data-testid='cart-item-amount'>{item.quantity}</span>
                          <button data-testid='cart-item-amount-decrease' 
                            onClick={() =>
                              this.handleDecreaseQuantity(item.product_id, item.attributes)
                            }
                          >
                            -
                          </button>
                        </div>

                      <img className="cart-img" src={item.image} alt="" />
                    </li>
                  ))}
                </ul>
              )}
              <p>
                <strong>Total Price:</strong> ${totalPrice}
              </p>
              <AddOrder cartItems={cartItems} clearCart={clearCart} />
            </div>
          )}
        </div>
      </nav>
    );
  }
}

export default Navbar;
