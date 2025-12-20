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
    showHeaders,
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
            {showHeaders && (
                <Header
                    title={title}
                    subtitle={subtitle}
                    breadcrumbs={breadcrumbs}
                    showBreadcrumbs={showBreadcrumbs}
                />
            )}
            <div className="flex-grow">{children}</div>
            <Footer menu={navigationItems} meta={meta} />
        </div>
    );
}
