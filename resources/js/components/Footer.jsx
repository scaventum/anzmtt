// resources/js/Components/Footer.jsx
import React from "react";
import { Link } from "@inertiajs/react";
import { defaultTheme } from "@/config/theme.js";

export default function Footer({ menu = [], meta, theme = defaultTheme }) {
    const { navTitle, navSubtitle } = meta;

    return (
        <footer className={`bg-gray-900 text-white`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="md:flex md:justify-between gap-8">
                    {/* Brand */}
                    <div className="mb-8">
                        <h2
                            className={`text-2xl font-bold ${theme.fontFamily.heading}`}
                        >
                            {navTitle}
                        </h2>
                        <p
                            className={`${theme.text.light} mt-2 ${theme.fontFamily.body}`}
                        >
                            {navSubtitle}
                        </p>
                    </div>

                    {/* Menu with submenus */}
                    <div className="flex flex-wrap gap-8">
                        {menu.map((item) => (
                            <div key={item.path} className="min-w-[150px]">
                                <Link
                                    href={`/${item.path}`}
                                    className={`font-semibold ${theme.fontFamily.body} text-white hover:text-gray-300 block mb-2`}
                                >
                                    {item.label}
                                </Link>

                                {/* Submenu items */}
                                {item.submenu && (
                                    <ul className="space-y-1">
                                        {item.submenu.map((subItem) => (
                                            <li key={subItem.path}>
                                                <Link
                                                    href={`/${subItem.path}`}
                                                    className={`${theme.text.light} hover:text-white text-sm block ${theme.fontFamily.body}`}
                                                >
                                                    {subItem.label}
                                                </Link>
                                            </li>
                                        ))}
                                    </ul>
                                )}
                            </div>
                        ))}
                    </div>
                </div>

                {/* Copyright */}
                <div className={`mt-8 pt-8 border-t border-gray-800`}>
                    <p
                        className={`${theme.text.light} text-sm ${theme.fontFamily.body}`}
                    >
                        {`© ${new Date().getFullYear()} ${navTitle}. All rights reserved.`}
                    </p>
                    <a
                        className={`${theme.text.disabled} text-xs ${theme.fontFamily.body}`}
                        href="https://ryandj.vercel.app/"
                        target="_blank"
                    >
                        Developed by Ryan
                    </a>
                </div>
            </div>
        </footer>
    );
}
