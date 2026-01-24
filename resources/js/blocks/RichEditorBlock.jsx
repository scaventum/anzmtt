import React from "react";
import { defaultTheme } from "@/config/theme";

export default function RichEditorBlock({ data, theme = defaultTheme }) {
    const { content, title, subtitle } = data;

    return (
        <section className="flex flex-col gap-8">
            {/* Header */}
            {(title || subtitle) && (
                <div className="flex flex-col gap-2 text-center">
                    {title && (
                        <h1
                            className={`text-3xl font-semibold ${theme.text.primary}`}
                        >
                            {title}
                        </h1>
                    )}
                    {subtitle && <h3 className="text-lg">{subtitle}</h3>}
                </div>
            )}

            {content && (
                <div
                    className={`
                            max-w-none
                            mb-10
                            ${theme.fontFamily.body}
                            rich
                        `}
                    dangerouslySetInnerHTML={{
                        __html: content,
                    }}
                />
            )}
        </section>
    );
}
