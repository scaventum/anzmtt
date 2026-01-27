import React, { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import { defaultTheme } from "@config/theme";

export default function Navigation({
    menu = [],
    meta = null,
    theme = defaultTheme,
}) {
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [openSubmenu, setOpenSubmenu] = useState(null);
    const [hoveredSubmenu, setHoveredSubmenu] = useState(null);
    const { url } = usePage();

    const { navTitle, navSubtitle } = meta;

    const toggleMobileMenu = () => {
        setIsMobileMenuOpen(!isMobileMenuOpen);
        setOpenSubmenu(null);
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
            const isActiveItem =
                hasActiveChild(item.submenu) || isActive(`/${item.path}`);

            if (isMobile) {
                return (
                    <div key={index} className="space-y-1">
                        <Link
                            href={`/${item.path}`}
                            onClick={(e) => {
                                if (openSubmenu !== index) {
                                    e.preventDefault();
                                    setOpenSubmenu(index);
                                }
                            }}
                            className={`block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 ${
                                isActiveItem
                                    ? `${theme.text.primary} ${theme.bg.secondary}`
                                    : `${theme.text.default} ${theme.text.hover} ${theme.bg.hover}`
                            }`}
                        >
                            <div className="flex items-center justify-between">
                                <span>{item.label}</span>
                                <svg
                                    className={`h-5 w-5 transition-transform duration-200 ${
                                        openSubmenu === index
                                            ? "rotate-180"
                                            : ""
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
                            </div>
                        </Link>

                        {openSubmenu === index && (
                            <div className="ml-4 space-y-1 border-l border-gray-200 pl-2">
                                {item.submenu.map((subItem, subIndex) => {
                                    const isSubActive = isActive(
                                        `/${subItem.path}`,
                                    );

                                    return (
                                        <Link
                                            key={subIndex}
                                            href={`/${subItem.path}`}
                                            className={`block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 ${
                                                isSubActive
                                                    ? `${theme.text.primary} ${theme.bg.secondary}`
                                                    : `${theme.text.default} ${theme.text.hover} ${theme.bg.hover}`
                                            }`}
                                            onClick={() => {
                                                setIsMobileMenuOpen(false);
                                                setOpenSubmenu(null);
                                            }}
                                        >
                                            {subItem.label}
                                        </Link>
                                    );
                                })}
                            </div>
                        )}
                    </div>
                );
            }

            // Desktop (CSS hover)
            return (
                <div key={index} className="relative group">
                    {/* Main menu item */}
                    <Link
                        href={`/${item.path}`}
                        className={`flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 ${
                            isActiveItem
                                ? `${theme.text.primary} ${theme.bg.secondary}`
                                : `${theme.text.default} ${theme.text.hover} ${theme.bg.hover}`
                        }`}
                    >
                        <span>{item.label}</span>
                        <svg
                            className="ml-1 h-4 w-4 transition-transform duration-200 group-hover:rotate-180"
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
                    </Link>

                    {/* Submenu */}
                    <div className="absolute left-0 top-full z-20 hidden group-hover:block">
                        {/* hover-safe padding */}
                        <div className="pt-2">
                            <div className="w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100">
                                {item.submenu.map((subItem, subIndex) => {
                                    const isSubActive = isActive(
                                        `/${subItem.path}`,
                                    );

                                    return (
                                        <Link
                                            key={subIndex}
                                            href={`/${subItem.path}`}
                                            className={`block px-4 py-2 text-sm ${
                                                isSubActive
                                                    ? `${theme.text.primary} ${theme.bg.secondary}`
                                                    : `${theme.text.default} ${theme.text.hover} ${theme.bg.hover}`
                                            }`}
                                        >
                                            {subItem.label}
                                        </Link>
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                </div>
            );
        }

        // Regular menu item (no submenu)
        const isActiveItem = isActive(`/${item.path}`);

        return (
            <Link
                key={index}
                href={`/${item.path}`}
                className={`${
                    isMobile ? "block px-3 py-2 text-base" : "px-3 py-2 text-sm"
                } font-medium rounded-md transition-colors duration-200 ${
                    isActiveItem
                        ? `${theme.text.primary} ${theme.bg.primary}`
                        : `${theme.text.default} ${theme.text.hover} ${theme.bg.hover}`
                }`}
                onClick={() => isMobile && setIsMobileMenuOpen(false)}
            >
                {item.label}
            </Link>
        );
    };

    return (
        <nav className={`${theme.bg.default} shadow-lg`}>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between h-16">
                    {/* Logo */}
                    <div className="flex items-center gap-3">
                        {/* Logo Image */}
                        <Link href="/" className="flex-shrink-0">
                            <img
                                src="/images/logoipsum.png"
                                alt="Logo"
                                width={40}
                                height={40}
                                className="object-contain"
                            />
                        </Link>

                        {/* Logo Text */}
                        <div className="leading-tight">
                            <Link
                                href="/"
                                className={`text-xl font-bold ${theme.text.primary}`}
                            >
                                {navTitle}
                            </Link>
                            {navSubtitle && (
                                <div className="text-xs">{navSubtitle}</div>
                            )}
                        </div>
                    </div>

                    {/* Desktop Navigation */}
                    <div className="hidden md:flex items-center space-x-1">
                        {menu.map((item, index) =>
                            renderMenuItem(item, index, false),
                        )}

                        {/* Contact button */}
                        <Link
                            href="/contact"
                            className={`
                                ml-2 inline-flex items-center
                                px-4 py-2
                                text-sm font-medium
                                rounded-md
                                border
                                ${theme.text.light}
                                border-current
                                ${theme.bg.primary}
                                ${theme.bg.hover}
                                transition
                            `}
                        >
                            Contact
                        </Link>
                    </div>

                    {/* Mobile Menu Button */}
                    <div className="md:hidden flex items-center">
                        <button
                            onClick={toggleMobileMenu}
                            className={`p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset ${theme.text.default} ${theme.text.hover} ${theme.focus.primary}`}
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
                        renderMenuItem(item, index, true),
                    )}

                    {/* Mobile contact button */}
                    <Link
                        href="/contact"
                        className={`
                            block mt-3 px-4 py-2
                            text-base font-medium
                            text-center
                            rounded-md
                            ${theme.text.light}
                            border-current
                            ${theme.bg.primary}
                            ${theme.bg.hover}
                            transition
                        `}
                        onClick={() => setIsMobileMenuOpen(false)}
                    >
                        Contact
                    </Link>
                </div>
            </div>
        </nav>
    );
}
