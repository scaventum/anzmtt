import React from "react";
import { defaultTheme } from "@/config/theme.js";
import { Link } from "@inertiajs/react";

export default function ContactBlock({ data, theme = defaultTheme }) {
    const { title, subtitle } = data;

    return (
        <div className="flex flex-col gap-2 text-center">
            <h1 className={`text-3xl font-semibold ${theme.text.primary}`}>
                {title}
            </h1>
            <h3 className={`text-lg`}>{subtitle}</h3>
            <Link
                href="contact"
                className={`inline-flex self-center items-center px-4 py-2 rounded-lg text-md font-semibold transition-all ${theme.bg.primary} ${theme.text.light} ${theme.bg.hover}`}
            >
                Contact us
            </Link>
        </div>
    );
}
