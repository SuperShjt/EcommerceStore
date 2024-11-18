import React, {Component} from "react";
import { useParams } from "react-router-dom";

class ProductPage extends Component {
  state = {
    product: null,
    loading: true,
    error: null,
  };

  async componentDidMount() {
    const { id } = this.props;
    const query = `
      {
        fullproduct(id: "${id}") {
          id
          name
          brand
          description
          inStock
          category
          price
          img_url
          attributes {
            display_value
            valuex
          }
        }
      }
    `;

    try {
      const response = await fetch("http://localhost/Scandiweb/Controller/test.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ query }),
      });
      const result = await response.json();

      if (result.errors) {
        this.setState({ error: result.errors[0].message, loading: false });
      } else {
        this.setState({ product: result.data.fullproduct, loading: false });
      }
    } catch (error) {
      this.setState({ error: error.message, loading: false });
    }
  }

  render() {
    const { product, loading, error } = this.state;

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error: {error}</p>;

    return (
      <div>
        <h1>{product.name}</h1>
        <p><strong>Brand:</strong> {product.brand}</p>
        <p><strong>Description:</strong> {product.description}</p>
        <p><strong>Price:</strong> ${product.price.toFixed(2)}</p>
        <p><strong>In Stock:</strong> {product.inStock ? "Yes" : "No"}</p>
        <div>
          <strong>Images:</strong>
          {product.img_url.map((url, index) => (
            <img key={index} src={url} alt={product.name} style={{ width: "200px" }} />
          ))}
        </div>
        <div>
          <strong>Attributes:</strong>
          {product.attributes.map((attr, index) => (
            <div key={index}>
              {attr.display_value} ({attr.valuex})
            </div>
          ))}
        </div>
      </div>
    );
  }
}

export default (props) => <ProductPage {...props} id={useParams().id} />;
