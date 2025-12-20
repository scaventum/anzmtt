import React from "react";
import Layout from "@layouts/Layout.jsx";
import Block from "@blocks/Block.jsx";

export default function Page({
    meta,
    data,
    navigationItems,
    breadcrumbs,
    showBreadcrumbs,
    showHeaders,
    newsPages,
}) {
    const { blocks } = data;

    return (
        <Layout
            meta={meta}
            data={data}
            navigationItems={navigationItems}
            breadcrumbs={breadcrumbs}
            showBreadcrumbs={showBreadcrumbs}
            showHeaders={showHeaders}
        >
            {blocks &&
                blocks.map((item, index) => (
                    <Block key={index} item={item} newsPages={newsPages} />
                ))}
        </Layout>
    );
}
