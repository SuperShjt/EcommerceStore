import React from "react";
import { Link } from "react-router-dom";
import QuickShop from "./QuickShop";
class ProductCard extends React.Component {
  render() {
    const {id, name, price, img_url , inStock } = this.props.product; 
    return (
      <div className="product-card">
        <Link to={`/product/${id}`}>

        <div className="product-image">
        <img src={img_url[0]} alt={name} className={inStock ? null  : "out-of-stock"} />
        {inStock ? null : <p className="out-of-stock-text">Out of stock</p>} 
        </div>
       
        <h3>{name}</h3>
        <p>${price.toFixed(2)}</p> 
        </Link>
        <QuickShop></QuickShop>
      </div>
    );
  }
}

export default ProductCard;
