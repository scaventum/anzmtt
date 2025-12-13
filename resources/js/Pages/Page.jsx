import React from "react";
import { Head } from "@inertiajs/react";
import Navigation from "@components/Navigation";
import Header from "@components/Header";
import Hero from "@components/Hero";
import { defaultTheme } from "@/config/theme";

export default function Page({
    meta,
    data,
    navigationItems,
    breadcrumbs,
    showBreadcrumbs,
}) {
    const { title, subtitle, hero } = data;

    return (
        <div className={defaultTheme.fontFamily.body}>
            <Head title={meta.title} />
            <Navigation menu={navigationItems} />
            {hero && <Hero {...hero} />}
            <Header
                title={title}
                subtitle={subtitle}
                breadcrumbs={breadcrumbs}
                showBreadcrumbs={showBreadcrumbs}
            />
        </div>
    );
}
