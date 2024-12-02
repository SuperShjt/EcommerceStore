import React from "react";



class GreyScreen extends React.Component {
    render() {
      const { cartStatus, children } = this.props;
      const isActive = cartStatus === "open";
  
      return (
        <div className={`bg-grey ${isActive ? "active" : ""}`}>
          {children}
        </div>
      );
    }
  }
export default GreyScreen