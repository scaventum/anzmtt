import React from "react";
import { defaultTheme } from "@/config/theme";
import { Link } from "@inertiajs/react";

export default function ErrorBlock({ data, theme = defaultTheme }) {
    const { body } = data;

    return (
        <div className="flex flex-col gap-4 items-start">
            <h1 className="text-xl">{body}</h1>
            <Link
                href="/"
                className={`inline-flex items-center px-8 py-4 rounded-lg text-lg font-semibold transition-all ${theme.bg.primary} ${theme.text.light} ${theme.bg.hover}`}
            >
                Back home
                <svg
                    className="ml-3 w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth={2}
                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                    />
                </svg>
            </Link>
        </div>
    );
}
