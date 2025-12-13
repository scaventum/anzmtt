import React from "react";
import { Head } from "@inertiajs/react";
import Navigation from "@components/Navigation";
import Header from "../Components/Header";

export default function Page({
    meta,
    data,
    navigationItems,
    breadcrumbs,
    showBreadcrumbs,
}) {
    const { title, subtitle } = data;

    return (
        <div>
            <Head title={meta.title} />
            <Navigation menu={navigationItems} />
            <Header
                title={title}
                subtitle={subtitle}
                breadcrumbs={breadcrumbs}
                showBreadcrumbs={showBreadcrumbs}
            />
        </div>
    );
}
