import React, {Component} from "react";
import ClothGrid from "../component/ClothGrid";

class ClothProducts extends Component{

    render(){
        return(
            <>
            <h1><strong>Clothes</strong></h1>
            <ClothGrid></ClothGrid>
            </>
        );
    }
}
export default ClothProducts;