import React, { Component } from "react";
import { StyleSheet, View, Text, ScrollView } from "react-native";
import { Table, Row, Rows } from "react-native-table-component";

//import HTML from 'react-native-render-html';
//import TableRenderer, { tableModel } from '@native-html/table-plugin';
//import WebView from 'react-native-webview';

class GradeAPI extends Component {
    state = {
        tableHead: ["Course", "Credit", "Credit Earned", "Grade", "GPA"],
        tableData: [],
    };

    render() {
        var state = this.state;

        fetch("https://physics.ehubbd.com/json/", {
            method: "GET",
        })
            .then((response) => response.json())
            .then((responseJson) => {
                var t = "";
                var temp2 = [];
                for (var key in responseJson["myrows"]) {
                    var temp = [];
                    //console.log(Object.keys(responseJson["myrows"][key]).length)
                    var flag = true;

                    for (var key2 in responseJson["myrows"][key]) {
                        if (
                            Object.keys(responseJson["myrows"][key]).length == 0
                        ) {
                            console.log("Trig");
                            continue;
                        }

                        if (
                            Object.keys(responseJson["myrows"][key]).length ==
                                6 &&
                            key2 == "Course Title"
                        ) {
                            continue;
                        }
                        if (
                            Object.keys(responseJson["myrows"][key]).length ==
                                2 &&
                            key > 1
                        ) {
                            //console.log(responseJson["myrows"][key])
                            if (flag) {
                                temp2.push([""]);
                            }
                            flag = !flag;
                        }

                        t = responseJson["myrows"][key][key2];

                        if (t.includes("<div")) {
                            t = t.replace(
                                '<div style="float:left; width:55%">',
                                ""
                            );
                            t = t.replace("</div>", "");
                            t = t.replace(
                                '<div style="float:left; width:44%">',
                                ""
                            );
                            t = t.replace("</div>", "");
                        }
                        if (t.includes("&nbsp;&nbsp;")) {
                            t = t.replace("&nbsp;&nbsp;", "");
                        }
                        temp.push(t);
                    }

                    if (temp.length > 0) {
                        temp2.push(temp);
                    }
                }

                //console.log(temp2)

                this.setState({
                    tableData: temp2,
                });
            })
            .catch((error) => {
                console.error(error);
            });

        //console.log(state.tableData)
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

export default GradeAPI;
