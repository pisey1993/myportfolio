export const POST_TYPE_ARTICLE = "article" as const;
export const POST_TYPE_VIDEO = "video" as const;
export type PostType = typeof POST_TYPE_ARTICLE | typeof POST_TYPE_VIDEO;
