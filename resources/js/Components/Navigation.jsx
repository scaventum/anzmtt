import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/react";

export default function Navigation({ menu = [] }) {
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [openSubmenu, setOpenSubmenu] = useState(null);
    const { url } = usePage();

    const toggleMobileMenu = () => {
        setIsMobileMenuOpen(!isMobileMenuOpen);
    };

    const toggleSubmenu = (index) => {
        setOpenSubmenu(openSubmenu === index ? null : index);
    };

    const isActive = (path) => {
        return url === path || url.startsWith(path + "/");
    };

    const hasActiveChild = (submenu) => {
        if (!submenu) return false;
        return submenu.some((item) => isActive(`/${item.path}`));
    };

    const renderMenuItem = (item, index, isMobile = false) => {
        if (item.submenu) {
            return (
                <div
                    key={index}
                    className={isMobile ? "space-y-1" : "relative"}
                >
                    <button
                        onClick={() => toggleSubmenu(index)}
                        className={`flex items-center justify-between w-full px-3 py-2 rounded-md ${
                            isMobile ? "text-base" : "text-sm"
                        } font-medium transition-colors duration-200 ${
                            hasActiveChild(item.submenu)
                                ? "text-green-800 bg-green-50"
                                : "text-gray-700 hover:text-green-800 hover:bg-green-50"
                        }`}
                    >
                        {item.label}
                        <svg
                            className={`ml-1 h-4 w-4 transition-transform duration-200 ${
                                openSubmenu === index ? "rotate-180" : ""
                            }`}
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>

                    {openSubmenu === index && (
                        <div
                            className={`${
                                isMobile
                                    ? "ml-4 space-y-1 border-l border-gray-200 pl-2"
                                    : "absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-100"
                            }`}
                        >
                            {item.submenu.map((subItem, subIndex) => (
                                <Link
                                    key={subIndex}
                                    href={`/${subItem.path}`}
                                    className={`block px-4 py-2 ${
                                        isMobile ? "text-base" : "text-sm"
                                    } ${
                                        isActive(`/${subItem.path}`)
                                            ? "text-green-800 bg-green-50"
                                            : "text-gray-700 hover:text-green-800 hover:bg-green-50"
                                    }`}
                                    onClick={() => {
                                        if (isMobile)
                                            setIsMobileMenuOpen(false);
                                        setOpenSubmenu(null);
                                    }}
                                >
                                    {subItem.label}
                                </Link>
                            ))}
                        </div>
                    )}
                </div>
            );
        }

        return (
            <Link
                key={index}
                href={`/${item.path}`}
                className={`${
                    isMobile ? "block px-3 py-2 text-base" : "px-3 py-2 text-sm"
                } font-medium rounded-md transition-colors duration-200 ${
                    isActive(`/${item.path}`)
                        ? "text-green-800 bg-green-50"
                        : "text-gray-700 hover:text-green-800 hover:bg-green-50"
                }`}
                onClick={() => isMobile && setIsMobileMenuOpen(false)}
            >
                {item.label}
            </Link>
        );
    };

    return (
        <nav className="bg-white shadow-lg">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    {/* Logo */}
                    <div className="flex items-center">
                        <Link
                            href="/"
                            className="text-xl font-bold text-green-800"
                        >
                            ANZMTT
                        </Link>
                    </div>

                    {/* Desktop Navigation */}
                    <div className="hidden md:flex items-center space-x-1">
                        {menu.map((item, index) =>
                            renderMenuItem(item, index, false)
                        )}
                    </div>

                    {/* Mobile Menu Button */}
                    <div className="md:hidden flex items-center">
                        <button
                            onClick={toggleMobileMenu}
                            className="text-gray-700 hover:text-green-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-700 p-2 rounded-md"
                            aria-expanded={isMobileMenuOpen}
                            aria-label="Toggle menu"
                        >
                            {isMobileMenuOpen ? (
                                <svg
                                    className="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            ) : (
                                <svg
                                    className="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth={2}
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                </svg>
                            )}
                        </button>
                    </div>
                </div>
            </div>

            {/* Mobile Menu */}
            <div
                className={`md:hidden ${isMobileMenuOpen ? "block" : "hidden"}`}
                id="mobile-menu"
            >
                <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t">
                    {menu.map((item, index) =>
                        renderMenuItem(item, index, true)
                    )}
                </div>
            </div>

            {/* Close dropdown when clicking outside (for desktop) */}
            {openSubmenu !== null && (
                <div
                    className="fixed inset-0 z-0"
                    onClick={() => setOpenSubmenu(null)}
                />
            )}
        </nav>
    );
}
