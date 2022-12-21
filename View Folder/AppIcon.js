import React, { useState } from "react";
import { View, TouchableHighlight } from "react-native";
import { MaterialCommunityIcons } from "@expo/vector-icons";

function AppIcon({
    name,
    style,
    size = 60,
    iconColor = "#555",
    pressColor = "#00704A",
    testPress,
}) {
    const [iconColor2, setColor] = useState(false);

    const test = () => {
        setColor(!iconColor2);
        console.log("Presssss");
    };

    return (
        <View
            style={{
                width: size,
                height: size,
                borderRadius: size / 2,
                justifyContent: "center",
                alignItems: "center",
            }}
        >
            <TouchableHighlight
                activeOpacity={0.6}
                underlayColor="#EEEEEE"
                onPress={testPress}
            >
                <MaterialCommunityIcons
                    name={name}
                    color={iconColor2 ? pressColor : iconColor}
                    size={size * 0.5}
                />
            </TouchableHighlight>
        </View>
    );
}

export default AppIcon;
