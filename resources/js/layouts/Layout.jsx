import React, { Children } from "react";
import { Head } from "@inertiajs/react";
import Header from "@components/Header";
import Hero from "@components/Hero";
import Navigation from "@components/Navigation";
import Footer from "@components/Footer";
import { defaultTheme } from "@/config/theme";

export default function Layout({
    meta,
    data,
    navigationItems,
    breadcrumbs,
    showBreadcrumbs,
    children,
}) {
    const { title, subtitle, hero } = data;

    return (
        <div
            className={`flex flex-col min-h-screen ${defaultTheme.fontFamily.body}`}
        >
            <Head title={meta.title} />
            <Navigation menu={navigationItems} meta={meta} />
            {hero && <Hero {...hero} />}
            <Header
                title={title}
                subtitle={subtitle}
                breadcrumbs={breadcrumbs}
                showBreadcrumbs={showBreadcrumbs}
            />
            <div className="flex-grow">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {children}
                </div>
            </div>
            <Footer menu={navigationItems} meta={meta} />
        </div>
    );
}
