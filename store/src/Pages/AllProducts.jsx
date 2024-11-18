import ProductGrid from "../component/ProductGrid"
import React,{Component} from "react";
class AllProducts extends Component{

    render(){
       return(
        <>
        <h1><strong>Products</strong></h1>
        <ProductGrid></ProductGrid>
        </>
       );
    }

}
export default AllProducts;