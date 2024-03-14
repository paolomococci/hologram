module.exports = {
    theme: {
        extend: {
            animation: {
                "lnr-spin-5": "spin 5s linear",
                "lnr-spin-10": "spin 10s linear",
                bs5l: "bounce-spin 5s linear",
            },
            keyframes: {
                "bounce-spin": {
                    "0%, 100%": {
                        transform: "scale(1)",
                    },
                    "25%": {
                        transform: "rotate(45deg)",
                    },
                    "50%": {
                        transform: "scale(1.5)",
                    },
                    "75%": {
                        transform: "scale(1)",
                    },
                },
            },
            colors: {
                "brick-fda": "#fda",
                "brick-fc8": "#fc8",
                "brick-fb8": "#fb8",
                "brick-f97": "#f97",
                "brick-e86": "#e86",
                "clay-fc5": "#fc5",
                "clay-fb5": "#fb5",
                "clay-fb0": "#fb0",
                "clay-fa2": "#fa2",
                "summer-sunrise-eff": "#eff",
                "summer-sunrise-def": "#def",
                "summer-sunrise-bef": "#bef",
                "spring-sunrise-adf": "#adf",
                "spring-sunrise-8cf": "#8cf",
                "spring-sunrise-6cf": "#6cf",
                "winter-sunrise-4be": "#4be",
                "winter-sunrise-0be": "#0be",
                "winter-sunrise-0ae": "#0ae",
            },
        },
    },
    plugins: [],
};
