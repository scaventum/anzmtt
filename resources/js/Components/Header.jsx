// resources/js/Components/Header.jsx
import React from "react";
import { Link } from "@inertiajs/react";
import { defaultTheme } from "@/config/theme";

export default function Header({
    title = "",
    subtitle = "",
    showBreadcrumbs = true,
    breadcrumbs = [],
    theme = defaultTheme,
}) {
    return (
        <div className="border-b border-gray-200">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="py-6">
                    {/* Breadcrumbs */}
                    {showBreadcrumbs && breadcrumbs.length > 0 && (
                        <nav className="mb-3" aria-label="Breadcrumb">
                            <ol className="flex items-center space-x-2 text-sm">
                                <li>
                                    <Link
                                        href="/"
                                        className={`${theme.text.default} ${theme.text.hover}`}
                                    >
                                        Home
                                    </Link>
                                </li>
                                {breadcrumbs.map((crumb, index) => (
                                    <React.Fragment key={index}>
                                        <li>
                                            <svg
                                                className="w-4 h-4 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    strokeWidth={2}
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>
                                        </li>
                                        <li>
                                            {crumb.href ? (
                                                <Link
                                                    href={crumb.href}
                                                    className={`${theme.text.default} ${theme.text.hover}`}
                                                >
                                                    {crumb.label}
                                                </Link>
                                            ) : (
                                                <span
                                                    className={`${theme.text.primary} font-medium`}
                                                >
                                                    {crumb.label}
                                                </span>
                                            )}
                                        </li>
                                    </React.Fragment>
                                ))}
                            </ol>
                        </nav>
                    )}

                    {/* Title and Subtitle */}
                    <div>
                        {title && (
                            <h1
                                className={`text-3xl font-bold ${theme.text.primary}`}
                            >
                                {title}
                            </h1>
                        )}
                        {subtitle && (
                            <p className={`mt-2 ${theme.text.default}`}>
                                {subtitle}
                            </p>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}
