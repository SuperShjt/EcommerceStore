import Navbar from "../component/Navbar";
import ProductGrid from "../component/ProductGrid"
import React,{Component} from "react";
class AllProducts extends Component{

    render(){
       return(
        <>
        <ProductGrid></ProductGrid>
        </>
       );
    }

}
export default AllProducts;