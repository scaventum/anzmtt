import React from "react";
import { Head } from "@inertiajs/react";
import Header from "@components/Header";
import Hero from "@components/Hero";
import Navigation from "@components/Navigation";
import Footer from "@components/Footer";
import { defaultTheme } from "@/config/theme";
import Layout from "@layouts/Layout";

export default function Page({
    meta,
    data,
    navigationItems,
    breadcrumbs,
    showBreadcrumbs,
}) {
    const { blocks } = data;

    return (
        <Layout
            meta={meta}
            data={data}
            navigationItems={navigationItems}
            breadcrumbs={breadcrumbs}
            showBreadcrumbs={showBreadcrumbs}
        >
            {blocks &&
                blocks.map((item, index) => (
                    <p key={index}>{JSON.stringify(item)}</p>
                ))}
        </Layout>
    );
}
