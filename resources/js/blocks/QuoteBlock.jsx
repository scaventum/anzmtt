import React from "react";
import { defaultTheme } from "@/config/theme";

export default function QuoteBlock({ data, theme = defaultTheme }) {
    const { quote, author } = data;

    return (
        <div className="flex flex-col gap-8 text-2xl text-center">
            {/* Content */}
            <p className={`font-semibold italic`}>"{quote}"</p>
            {author && <span>{author}</span>}
        </div>
    );
}
