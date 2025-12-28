// resources/js/Components/Hero.jsx
import React from "react";
import { Link } from "@inertiajs/react";
import { defaultTheme } from "@/config/theme";

export default function Hero({
    backgroundImage,
    title,
    subtitle,
    ctaLink,
    theme = defaultTheme,
    fallbackBackground = true,
}) {
    const hasBackgroundImage = backgroundImage?.src;
    const hasCtaLink = ctaLink?.href && ctaLink?.label;

    return (
        <div
            className={`relative min-h-[500px] ${
                !hasBackgroundImage && fallbackBackground
                    ? theme.bg.primary
                    : ""
            }`}
        >
            {hasBackgroundImage && (
                <div className="absolute inset-0 z-0">
                    <img
                        src={`/storage/${backgroundImage.src}`}
                        alt={title}
                        className="w-full h-full object-cover"
                    />
                    <div className="absolute inset-0 bg-black/40"></div>
                </div>
            )}

            {/* Content */}
            <div className="relative z-10">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div
                        className={`py-24 md:py-36 ${
                            hasBackgroundImage ? "text-white" : ""
                        }`}
                    >
                        <div className="max-w-2xl">
                            {/* Title */}
                            {title && (
                                <h1
                                    className={`text-4xl md:text-5xl lg:text-6xl font-bold mb-6  ${
                                        hasBackgroundImage
                                            ? "text-white"
                                            : theme.text.light
                                    }`}
                                >
                                    {title}
                                </h1>
                            )}

                            {/* Subtitle */}
                            {subtitle && (
                                <p
                                    className={`text-xl md:text-2xl mb-10 ${
                                        hasBackgroundImage
                                            ? "text-gray-200"
                                            : theme.text.light
                                    }`}
                                >
                                    {subtitle}
                                </p>
                            )}

                            {/* CTA Button */}
                            {hasCtaLink && (
                                <Link
                                    href={ctaLink.href}
                                    className={`inline-flex items-center px-8 py-4 rounded-lg text-lg font-semibold transition-all ${
                                        hasBackgroundImage
                                            ? "bg-white text-green-800 hover:bg-gray-100"
                                            : `${theme.bg.default} ${theme.text.primary} hover:${theme.bg.hover}`
                                    }`}
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
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
