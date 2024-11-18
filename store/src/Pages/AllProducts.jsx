import ProductGrid from "../component/ProductGrid"
import React,{Component} from "react";
class AllProducts extends Component{

    render(){
       return(
        <main className="page-layout">
        <h1><strong>Products</strong></h1>
        <ProductGrid></ProductGrid>
        </main>
       );
    }

}
export default AllProducts;