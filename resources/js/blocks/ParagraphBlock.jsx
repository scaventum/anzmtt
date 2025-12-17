import React from "react";
import { defaultTheme } from "@/config/theme";

export default function ParagraphBlock({ data, theme = defaultTheme }) {
    const { content, logo } = data;

    return (
        <div className="flex flex-col gap-8 md:flex-row md:items-start">
            {/* Logo */}
            {logo && (
                <div className="flex-shrink-0">
                    <img
                        src="storage/logo/logoipsum-411.png"
                        alt="logo"
                        className="h-50"
                    />
                </div>
            )}

            {/* Content */}
            {content && (
                <p className={`${theme.text.primary} text-xl font-semibold`}>
                    {content}
                </p>
            )}
        </div>
    );
}
