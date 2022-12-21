import React from "react";
import { View } from "react-native";

function QRAPI({ children, style, msg }) {
    console.log(msg.split("_"));
    var d = msg.split("_");

    var requestOptions = {
        method: "GET",
        redirect: "follow",
    };

    var urltopost =
        "https://server.ehubbd.com/eas/verify/?course=" +
        d[0] +
        "&sec=" +
        d[1] +
        "&otp=" +
        d[2] +
        "&id=" +
        "19121040" +
        "&unix=" +
        d[3];

    //console.log(urltopost);

    fetch(urltopost, requestOptions)
        .then((response) => response.text())
        .then((result) => {
            console.log(result);
            alert(result);
        })
        .catch((error) => console.log("error", error));
}

export default QRAPI;
