import React from "react";
import { StyleSheet, View, ScrollView, Text } from "react-native";
import LoginScreen from "react-native-login-screen";

function MyLoginScreen({ children, style, testPress }) {
    return (
        <LoginScreen
            logoImageSource={require("../assets/bracu_logo.png")}
            onLoginPress={testPress}
            disableSignup={true}
            disableSocialButtons={true}
        />
    );
}

const styles = StyleSheet.create({
    bottom: {
        fontFamily: "Roboto",
        fontSize: 18,
        fontWeight: "bold",
        paddingBottom: 5,
        paddingLeft: 10,
    },
    bottom2: {
        fontFamily: "Roboto",
        fontSize: 20,
        fontWeight: "bold",
        paddingTop: 10,
        paddingLeft: 10,
    },
    container: {
        width: "100%",
        height: "100%",
        alignContent: "flex-end",
        flexDirection: "column",
        marginTop: 20,
    },
    welcome: {
        fontFamily: "Roboto",
        fontSize: 25,
        fontWeight: "bold",
        padding: 10,
    },
});

export default MyLoginScreen;
