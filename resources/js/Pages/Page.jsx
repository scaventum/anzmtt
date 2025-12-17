import React from "react";
import Layout from "@layouts/Layout";
import ParagraphBlock from "@blocks/ParagraphBlock";
import UnorderedListBlock from "@blocks/UnorderedListBlock";
import Block from "../blocks/Block";

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
                blocks.map((item, index) => <Block key={index} item={item} />)}
        </Layout>
    );
}
