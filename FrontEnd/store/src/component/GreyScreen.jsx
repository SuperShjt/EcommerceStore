import React from "react";



class GreyScreen extends React.Component {
    render() {
      const { cartStatus, children , toggleCart } = this.props;
      const isActive = cartStatus === "open";
  
      return (
        <div className={`bg-grey ${isActive ? "active" : ""}`} onClick={toggleCart}>
          {children}
        </div>
      );
    }
  }
export default GreyScreen