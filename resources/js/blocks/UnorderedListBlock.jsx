import React from "react";
import { defaultTheme } from "@/config/theme.js";
import { Link } from "@inertiajs/react";

export default function UnorderedListBlock({
    data,
    theme = defaultTheme,
    hasBackgroundImage = false,
}) {
    if (!data) return null;

    const { title, ctaLink, listItems } = data;

    return (
        <div className="space-y-6">
            {/* Title */}
            {title && (
                <h2 className={`${theme.text.primary} text-xl font-semibold`}>
                    {title}
                </h2>
            )}

            {/* List */}
            {Array.isArray(listItems) && listItems.length > 0 && (
                <ul className="list-disc pl-6 space-y-2">
                    {listItems.map((item, index) => (
                        <li key={index} className={theme.text.secondary}>
                            {item.listItem}
                        </li>
                    ))}
                </ul>
            )}

            {/* CTA Button (Right aligned) */}
            {ctaLink?.href && ctaLink?.label && (
                <div className="flex justify-end">
                    <Link
                        href={ctaLink.href}
                        className={`inline-flex items-center px-8 py-4 rounded-lg text-lg font-semibold transition-all ${theme.bg.primary} ${theme.text.light} ${theme.bg.hover}`}
                    >
                        {ctaLink.label}
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
            )}
        </div>
    );
}
