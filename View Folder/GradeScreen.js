import React from "react";
import { StyleSheet, View, ScrollView, Text } from "react-native";

import GradeAPI from "../Model Folder/GradeAPI";
import LoginAPI from "../Model Folder/LoginAPI";

function GradeScreen({ children, style }) {
    return (
        <View style={styles.container}>
            <GradeAPI />
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        width: "100%",
        height: "100%",
        alignContent: "flex-end",
        flexDirection: "column-reverse",
    },
    welcome: {
        fontFamily: "Roboto",
        fontSize: 25,
        fontWeight: "bold",
        padding: 10,
    },
});

export default GradeScreen;
