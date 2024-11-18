import React, {Component} from "react";
import ClothGrid from "../component/ClothGrid";

class ClothProducts extends Component{

    render(){
        return(
            <main className="page-layout">
            <h1><strong>Clothes</strong></h1>
            <ClothGrid></ClothGrid>
            </main>
        );
    }
}
export default ClothProducts;