import React, { useState } from "react";
import { View, StyleSheet, Text } from "react-native";

import AppScreen from "../View Folder/AppScreen";
import GradeScreen from "../View Folder/GradeScreen";
import HomeScreen from "../View Folder/HomeScreen";
import MyLoginScreen from "../View Folder/MyLoginScreen";
import AppIcon from "../View Folder/AppIcon";
import ClassScreen from "../View Folder/ClassScreen";
import ScheduleScreen from "../View Folder/ScheduleScreen";
import QRScreen from "../View Folder/QRScreen";

class AppController extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            partA: "",
            partB: <MyLoginScreen testPress={this.loginClick} />,
        };
    }

    loginClick = () => {
        console.log("login");
        this.setState({
            partA: (
                <View style={[styles.panel]}>
                    <AppIcon name="home" testPress={this.homePress} />
                    <AppIcon name="account-group" testPress={this.classPress} />
                    <AppIcon
                        name="qrcode-scan"
                        size={55}
                        testPress={this.QRPress}
                    />
                    <AppIcon
                        name="format-list-bulleted"
                        testPress={this.schedulePress}
                    />
                    <AppIcon name="star" testPress={this.gradePress} />
                </View>
            ),
            partB: <HomeScreen />,
        });
    };

    homePress = () => {
        console.log("home");
        this.setState({
            partB: <HomeScreen />,
        });
    };
    classPress = () => {
        console.log("class");
        this.setState({
            partB: <ClassScreen />,
        });
    };

    QRPress = () => {
        console.log("QR");
        this.setState({
            partB: <QRScreen />,
        });
    };

    schedulePress = () => {
        console.log("sched");
        this.setState({
            partB: <ScheduleScreen />,
        });
    };

    gradePress = () => {
        console.log("grade");
        this.setState({
            partB: <GradeScreen />,
        });
    };

    render() {
        return (
            <AppScreen style={styles.container}>
                {this.state.partA}
                {this.state.partB}
            </AppScreen>
        );
    }
}

const styles = StyleSheet.create({
    container: {
        width: "100%",
        height: "100%",
        alignContent: "flex-end",
        flexDirection: "column-reverse",
        marginTop: 40,
    },
    panel: {
        flexDirection: "row",
        justifyContent: "space-around",
        alignItems: "center",
        backgroundColor: "#eee",
    },
    welcome: {
        fontFamily: "Roboto",
        fontSize: 25,
        fontWeight: "bold",
        padding: 10,
    },
    welcome2: {
        fontFamily: "Roboto",
        fontSize: 15,
        fontWeight: "bold",
        padding: 10,
        color: "red",
    },
});

export default AppController;
