import React from "react";
import { Link } from "react-router-dom";
import QuickShop from "./QuickShop";

class ProductCard extends React.Component {
  render() {
    const { product, addToCart } = this.props; 
    const { id, name, price, img_url, inStock } = product;

    return (
      <div className="product-card" data-testid={`product-${id}`}  >
        <Link to={`/product/${id}`}>
          <div className="product-image">
            <img src={img_url[0]} alt={name} className={inStock ? null : "out-of-stock"} />
            {inStock ? null : <p className="out-of-stock-text">Out of stock</p>}
          </div>
        </Link>
        <h3>{name}</h3>
        <p>${price.toFixed(2)}</p>
        {inStock && <QuickShop product={product} addToCart={addToCart} />} 
      </div>
    );
  }
}

export default ProductCard;
