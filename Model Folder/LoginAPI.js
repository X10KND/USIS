import React, { Component } from "react";
import { StyleSheet, View, Text, ScrollView } from "react-native";

class LoginAPI extends Component {
    state = {};

    render() {
        //var state = this.state;

        var myHeaders = new Headers();
        myHeaders.append(
            "Cookie",
            "JSESSIONID=B8EE7F448A7E288B9B9FB9F03143DBAF; SRVNAME=USISB"
        );

        var requestOptions = {
            method: "POST",
            //headers: myHeaders,
            redirect: "follow",
        };

        fetch(
            "https://usis.bracu.ac.bd/academia/j_spring_security_check?j_username=mubinsaeef1@gmail.com&j_password=Mubin@123",
            requestOptions
        ).then((response) => {
            console.log("1", response.text());
        });
        //console.log(state.tableData)
        return <Text></Text>;
    }
}

const styles = StyleSheet.create({
    head: {
        height: 60,
        backgroundColor: "#f1f8ff",
    },
    text: {
        margin: 6,
        fontSize: 15,
        fontWeight: "bold",
        textAlign: "center",
    },
    text2: {
        margin: 6,
        fontSize: 12,
    },
});

export default LoginAPI;
