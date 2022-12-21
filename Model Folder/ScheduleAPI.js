import React, { Component } from "react";
import { StyleSheet, View, Text, ScrollView } from "react-native";
import { Table, Row, Rows } from "react-native-table-component";

//import HTML from 'react-native-render-html';
//import TableRenderer, { tableModel } from '@native-html/table-plugin';
//import WebView from 'react-native-webview';

class ScheduleAPI extends Component {
    state = {
        tableHead: ["Day", "Course", "Time"],
        tableData: [],
    };

    render() {
        var state = this.state;

        fetch("https://physics.ehubbd.com/json2/", {
            method: "GET",
        })
            .then((response) => response.json())
            .then((responseJson) => {
                var t = "";
                var temp2 = [];
                for (var key in responseJson["myrows"]) {
                    var temp = [];

                    var flag = true;

                    for (var key2 in responseJson["myrows"][key]) {
                        t = responseJson["myrows"][key][key2];

                        temp.push(t);
                    }

                    if (temp.length > 0) {
                        temp2.push(temp);
                    }
                }

                this.setState({
                    tableData: temp2,
                });
            })
            .catch((error) => {
                console.error(error);
            });

        return (
            <ScrollView>
                <Table borderStyle={{ borderWidth: 2, borderColor: "#111" }}>
                    <Row
                        data={state.tableHead}
                        style={styles.head}
                        textStyle={styles.text}
                    />
                    <Rows data={state.tableData} textStyle={styles.text2} />
                </Table>
            </ScrollView>
        );
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

export default ScheduleAPI;
