import React, { Component } from "react";
import { StyleSheet, Text, ScrollView, Linking } from "react-native";
import { Table, Row, Rows } from "react-native-table-component";

class ClassAPI extends Component {
    state = {
        tableHead: ["Course", "Sec", "Click to Join"],
        tableData: [],
    };

    render() {
        var state = this.state;

        fetch("https://physics.ehubbd.com/json3/", {
            method: "GET",
        })
            .then((response) => response.json())
            .then((responseJson) => {
                var t = "";
                var temp2 = [];
                for (var key in responseJson["myrows"]) {
                    if (Object.keys(responseJson["myrows"][key]).length == 0) {
                        continue;
                    }

                    var temp = [];
                    var flag = true;

                    temp.push(responseJson["myrows"][key]["Course"]);
                    temp.push(responseJson["myrows"][key]["Sec"]);
                    temp.push(
                        <Text
                            style={styles.text3}
                            onPress={() =>
                                Linking.openURL(
                                    responseJson["myrows"][key]["Link"]
                                )
                            }
                        >
                            {responseJson["myrows"][key]["Platform"]}
                        </Text>
                    );

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

export default ClassAPI;
