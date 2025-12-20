import React from "react";
import { defaultTheme } from "@/config/theme";
import { Link } from "@inertiajs/react";

export default function NewsBlock({ data, theme = defaultTheme }) {
    const { title, supertitle } = data;

    return (
        <div className="flex flex-col gap-2 text-center">
            <h3 className={`text-lg`}>{supertitle}</h3>
            <h1 className={`text-3xl font-semibold ${theme.text.primary}`}>
                {title}
            </h1>
        </div>
    );
}
