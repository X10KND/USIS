import React from "react";
import { StyleSheet, View, ScrollView, Text } from "react-native";

function HomeScreen({ children, style }) {
    return (
        <View style={styles.container}>
            <Text style={styles.welcome}>Welcome back, Asef Jamil Ajwad</Text>
            <Text style={styles.bottom}>Department EEE</Text>
            <Text style={styles.bottom}>ID: 19121040</Text>
            <Text style={styles.bottom}>Email: sigma.asef@gmail.com</Text>
            <Text style={styles.bottom2}>Credits Completed: 159.5</Text>
        </View>
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

export default HomeScreen;
