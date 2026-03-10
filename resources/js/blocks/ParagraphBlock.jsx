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
                        src="/images/icon-with-caption.png"
                        alt="logo"
                        className="h-50 object-contain"
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
