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
                "clay-fda": "#fda",
                "clay-fc8": "#fc8",
                "clay-fc5": "#fc5",
                "clay-fb5": "#fb5",
                "clay-fb0": "#fb0",
                "clay-fa2": "#fa2",
                "clay-fb8": "#fb8",
                "clay-f97": "#f97",
                "clay-e86": "#e86",
                "sunrise-eff": "#eff",
                "sunrise-def": "#def",
                "sunrise-bef": "#bef",
                "sunrise-adf": "#adf",
                "sunrise-8cf": "#8cf",
                "sunrise-6cf": "#6cf",
                "sunrise-4be": "#4be",
                "sunrise-0be": "#0be",
                "sunrise-0ae": "#0ae",
            },
        },
    },
    plugins: [],
};
