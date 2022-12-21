import React from "react";
import { StyleSheet, View } from "react-native";
import ClassAPI from "../Model Folder/ClassAPI";

function ClassScreen({ children, style }) {
    return (
        <View style={styles.container}>
            <ClassAPI />
        </View>
    );
}

const styles = StyleSheet.create({
    head: {
        height: 40,
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
        fontSize: 15,
        textAlign: "center",
    },
    text3: {
        margin: 6,
        fontSize: 15,
        textAlign: "center",
        color: "blue",
    },
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
    },
});

export default ClassScreen;
