import React from "react";
import { StyleSheet, View, ScrollView, Text } from "react-native";

import ScheduleAPI from "../Model Folder/ScheduleAPI";

function ScheduleScreen({ children, style }) {
    return (
        <View style={styles.container}>
            <ScheduleAPI />
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

export default ScheduleScreen;
